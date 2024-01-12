<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Problem;

class CodeExecutorController extends Controller
{
    public function executeCode(Request $request)
    {
        $problemId = $request->input('problem_id');
        $problem = Problem::find($problemId);

        if (!$problem) {
            return response()->json(['error' => 'Problem not found.']);
        }
        $uploadedFile = $request->file('code_file');
        // Check if a file was uploaded
        if ($uploadedFile) {
            // Read the file content
            $code = file_get_contents($uploadedFile->path());
            

            $language = $request->input('language'); // Add language selection option

        } else {
            // Use the code from the textarea
            $code = $request->input('code');
            $language = $request->input('language'); // Add language selection option
        }

        $testCases = $problem->testCases;
        $testCaseResults = [];
        $numCorrect = 0;

        foreach ($testCases as $testCase) {
            $tmpCodeFile = $this->createTempFile('code-', $this->getFileExtension($language), $code);
            $tmpInputFile = $this->createTempFile('input-', '', Storage::get($testCase->input_file));

            [$compiledFileName, $compileOutputResult] = $this->compileCode($tmpCodeFile, $language);

            if ($compiledFileName !== null) {
                $runOutput = $this->runCode($compiledFileName, $tmpInputFile, $language, $tmpCodeFile);
                $result = (Storage::get($testCase->output_file) == $runOutput[0]) ? 1 : 0;
                $numCorrect += $result;

                $testCaseResults[] = [
                    'compile_return_code' => 0,
                    'result' => ($result == 1) ? 'Correct' : 'Not Correct',
                    'compile_output' => $compileOutputResult,
                    'run_output' => implode("\n", $runOutput),
                ];

                $this->cleanupTempFiles([$tmpCodeFile, $tmpInputFile, $compiledFileName]);
            } else {
                $testCaseResults[] = [
                    'compile_return_code' => 1,
                    'compile_output' => $compileOutputResult,
                ];
            }
        }

        $maxScore = 100;
        $score = ($numCorrect / count($testCases)) * $maxScore;
        $problem->score = $score;
        $problem->save();

        session()->flash('score', $score);
        return redirect()->back()->with(['score' => $score]);
    }
    private function createTempFile($prefix, $suffix, $content)
    {
        $tmpFile = tempnam(sys_get_temp_dir(), $prefix) . $suffix;
        file_put_contents($tmpFile, $content);
        return $tmpFile;
    }

    private function compileCode($tmpCodeFile, $language)
    {
        switch ($language) {
            case 'cpp':
                exec("g++ -o $tmpCodeFile.out $tmpCodeFile 2>&1", $compileOutput, $compileReturnCode);
                break;
            case 'java':
                exec("javac $tmpCodeFile 2>&1", $compileOutput, $compileReturnCode);
                break;
            case 'python':
                // No compilation needed for Python
                return [$tmpCodeFile, null];
            case 'c':
                exec("gcc -o $tmpCodeFile.out $tmpCodeFile 2>&1", $compileOutput, $compileReturnCode);
                break;
            case 'php':
                // No compilation needed for PHP
                return [$tmpCodeFile, null];
            // Add more cases for additional languages if needed
            default:
                return [null, 'Unsupported language'];
        }

        $compiledFileName = $compileReturnCode === 0 ? "$tmpCodeFile.out" : null;

        return [$compiledFileName, $this->getCompileOutput($compileOutput)];
    }

    private function runCode($compiledFileName, $tmpInputFile, $language, $tmpCodeFile)
    {
        $runOutput = null;
        $runReturnCode = null;

        switch ($language) {
            case 'cpp':
                exec("$compiledFileName < $tmpInputFile", $runOutput, $runReturnCode);
                break;
            case 'java':
                exec("java -cp " . escapeshellarg(dirname($compiledFileName)) . " " . basename($compiledFileName, '.java') . " < $tmpInputFile", $runOutput, $runReturnCode);
                break;
            case 'python':
                exec("python $compiledFileName < $tmpInputFile", $runOutput, $runReturnCode);
                break;
            case 'c':
                exec("$compiledFileName < $tmpInputFile", $runOutput, $runReturnCode);
                break;
            case 'php':
                exec("php $tmpCodeFile < $tmpInputFile", $runOutput, $runReturnCode);
                break;
            // Add more cases for additional languages if needed
        }

        return $runOutput;
    }

    private function cleanupTempFiles($files)
    {
        foreach ($files as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    private function getCompileOutput($compileOutput)
    {
        \Log::info("Compilation output: " . implode("\n", $compileOutput));
        return ['compile_output' => implode("\n", $compileOutput)];
    }

    private function getFileExtension($language)
    {
        switch ($language) {
            case 'cpp':
                return '.cpp';
            case 'java':
                return '.java';
            case 'python':
                return '.py';
            case 'c':
                return '.c';
            case 'php':
                return '.php';
            // Add more cases for additional languages if needed
            default:
                return '.txt'; // Default extension
        }
    }
}
