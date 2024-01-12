<table>
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
        <td class="content_problem">
            <button style="background:blue; color:white">edit</button>
            <button style="background:blue; color:white">delete</button>
        </td>
    </tr>
</table>