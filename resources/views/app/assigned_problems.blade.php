<!-- resources/views/assigned_problems.blade.php -->

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="create-wrapper">
                        <h1 class="problems_bar">Assigned Problems for {{ $user->name }}</h1>

                        <table>
                            <thhead>
                                <tr>
                                    <th class="title_problem_unit">Code</td>
                                    <th class="title_problem_unit">Title</td>
                                    <th class="title_problem_unit">Level</td>
                                    <th class="title_problem_unit">Score</td>
                                    <th class="title_problem_unit">Tag</td>
                                    <th class="title_problem_unit">Assigner</td>
                                </tr>
                            </thhead>
                            <tbody>
                                @if ($assignedProblems->isEmpty())
                                <tr>
                                    <th class="title_problem_unit">No problems assigned.</td>
                                </tr>
                                @else
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
                                        {{$problem->problem_user->first()->user->name}}
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>