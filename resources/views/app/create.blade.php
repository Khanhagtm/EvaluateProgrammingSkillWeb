<x-app-layout>
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="create-wrapper">
                    <form action="/post" method="post" enctype="multipart/form-data">
                        @csrf
                            <div>
                                <h1>Enter Code-id</h1>
                                <input type="text" name="code_id">
                            </div>

                            <div>
                                <h1>Fill Title</h1>
                                <input type="text" name="title">
                            </div>

                            <div>
                                <h1>Fill Description</h1>
                                <textarea name="description" id="code-decription" cols="30" rows="10"></textarea>
                            </div>

                            <div>
                                <h1>Select Level</h1>
                                <input type="radio" id="easy" name="level" value="easy">
                                <label for="easy">Easy</label>

                                <input type="radio" id="medium" name="level" value="medium">
                                <label for="medium">Medium</label>

                                <input type="radio" id="hard" name="level" value="hard">
                                <label for="hard">Hard</label>
                            </div>

                            <div>
                                <h1>Enter Tags</h1>
                                <input type="text" name="tags">
                            </div>

                            <br>
                            <h1>Insert Test Cases</h1>
                            <table>
                                @for ($i = 1; $i <= 5; $i++)
                                    <tr>
                                        <td>
                                            <h1>Select file input {{ $i }}:</h1>
                                            <input type="file" name="input{{ $i }}" id="input{{ $i }}" required>
                                        </td>
                                        <td>
                                            <h1>Select file output {{ $i }}:</h1>
                                            <input type="file" name="output{{ $i }}" id="output{{ $i }}" required>
                                        </td>
                                    </tr>
                                @endfor
                            </table>
                            
                            
                            <br>
                            <button type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

