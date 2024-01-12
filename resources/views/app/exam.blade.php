<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="task-bar">
                        <div class="problems_bar">
                            <p>Problems</p>
                        </div>

                        

                        <div class="search-container">
                            <!-- Form tìm kiếm -->
                            <form action="{{ route('problems.search') }}" method="POST">
                                @csrf
                                <!-- Input tìm kiếm với icon từ Font Awesome -->
                                <input type="text" name="query" class="search-input" placeholder="Search problems">
                                <button type="submit" class="search-button">
                                    <i class="fas fa-search"></i> <!-- Icon tìm kiếm -->
                                </button>
                            </form>
                        </div>
                    </div>

                    <table>
                        <thhead>
                            <tr>
                                <th class="title_problem_unit">Code</td>
                                <th class="title_problem_unit">Title</td>
                                <th class="title_problem_unit">Level</td>
                                <th class="title_problem_unit">Score</td>
                                <th class="title_problem_unit">Tag</td>
                                <th class="title_problem_unit">Action</td>
                            </tr>
                        </thhead>
                        <tbody>
                            @foreach($problems->sortByDesc('id') as $index => $problem)
                            <tr>
                                <td class="content_problem">{{$problem->code}}</td>
                                <td class="content_problem">
                                    <a href="{{ url('/app/show', $problem->id) }}">
                                        {{$problem->title}}
                                    </a>
                                </td>
                                <td class="content_problem">{{$problem->level}}</td>
                                <td class="content_problem">{{$problem->score}}</td>
                                <td class="content_problem">{{$problem->tag}}</td>
                                <td class="content_problem" style="display: flex">
                                    <form action="/app/edit/{{$problem->id}}" method="get" class="btn btn-primary m-2">
                                        @csrf
                                        <button class="btn btn-danger m-2" type="submit">
                                            <i class="fa fa-pen"></i>
                                        </button>
                                    </form>

                                    <form action="/app/delete/{{$problem->id}}" method="POST"
                                        class="btn btn-primary m-2">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger m-2" type="submit">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>




                </div>
            </div>
        </div>
    </div>
</x-app-layout>