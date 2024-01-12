<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>Welcome to Code Executor</h1>
                    <h3>Title: {{$problem->title}}</h3>
                    <h3>Description:</h3>
                    <p>{{$problem->decription}}</p>

                    <form action="/execute-code" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="language">Select Programming Language:</label>
                        <select name="language" id="language">
                            <option value="cpp">C++</option>
                            <option value="java">Java</option>
                            <option value="python">Python</option>
                            <option value="c">C</option>
                            <option value="php">PHP</option>
                            <!-- Add more language options as needed -->
                        </select>
                        <div class="mb-4">
                            <label for="code" class="block text-gray-700 text-sm font-bold mb-2">Enter Code:</label>
                            <textarea name="code" id="code"
                                class="shadow appearance-none border rounded w-full py-2 px-3" rows="10"></textarea>
                        </div>

                        <!-- <div class="mb-4">
                            <label for="input" class="block text-gray-700 text-sm font-bold mb-2">Enter Input:</label>
                            <textarea name="input" id="input"
                                class="shadow appearance-none border rounded w-full py-2 px-3" rows="5"></textarea>
                        </div> -->
                        <input type="file" name="code_file" >
                        <br>
                        <input type="hidden" name="problem_id" value="{{ $problem->id }}">

                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-auto rounded" style="display: flex;
    justify-content: center;">Submit code</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>