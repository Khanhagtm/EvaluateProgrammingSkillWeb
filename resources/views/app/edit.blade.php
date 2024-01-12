<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="create-wrapper">
                        <form action="/app/update/{{$problem->id}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div>
                                <h1>Enter Code-id</h1>
                                <input type="text" name="code_id" value="{{ $problem->code }}">
                            </div>

                            <div>
                                <h1>Fill Title</h1>
                                <input type="text" name="title" value="{{ $problem->title }}">
                            </div>

                            <div>
                                <h1>Fill Description</h1>
                                <textarea name="description" id="code-decription" cols="30"
                                    rows="10">{{ $problem->decription }}</textarea>
                            </div>

                            <div>
                                <h1>Select Level</h1>
                                <input type="radio" id="easy" name="level" value="easy" {{ $problem->level == 'easy' ?
                                'checked' : '' }}>
                                <label for="easy">Easy</label>

                                <input type="radio" id="medium" name="level" value="medium" {{ $problem->level ==
                                'medium' ? 'checked' : '' }}>
                                <label for="medium">Medium</label>

                                <input type="radio" id="hard" name="level" value="hard" {{ $problem->level == 'hard' ?
                                'checked' : '' }}>
                                <label for="hard">Hard</label>
                            </div>

                            <div>
                                <h1>Enter Tags</h1>
                                <input type="text" name="tags" value="{{ $problem->tag }}">
                            </div>

                            <br>
                            <br>

                            <!-- Danh sách người dùng -->
                            <label for="assigned_users">Assign to Users:</label>
                            @foreach ($users as $user)
                            <div>
                                <input type="checkbox" name="assigned_users[]" value="{{ $user->id }}"> {{ $user->name
                                }}
                            </div>
                            @endforeach

                            <!-- Trường ẩn để lưu assigner_id -->
                            <input type="hidden" name="assigner_id" value="{{ auth()->id() }}">

                            <br>

                            <button type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>