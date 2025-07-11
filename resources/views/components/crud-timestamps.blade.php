@props(['data'])

<br>
<table  class="table table-hover table-condensed">
    <tbody>
        <tr>
            <th  style="width: 250px;"  scope="col" class="bg-secondary text-white">Created At</th>
            <td>{{ $data->created_at->isoFormat(config('constant.DATE_FORMAT.LONG')) }}
                <br/>
                by
                @if (is_null($data->created_by))
                    N/A
                @elseif ($data->createdByUser)
                    {{ $data->createdByUser->name }} ({{ $data->createdByUser->email }})
                @else
                    {{ $data->created_by }}
                @endif
            </td>
        </tr>
        <tr>
            <th scope="col" class="bg-secondary text-white">Updated At</th>
            <td>{{ $data->updated_at->isoFormat(config('constant.DATE_FORMAT.LONG')) }}
                <br/>
                by
                @if (is_null($data->updated_by))
                    N/A
                @elseif ($data->updatedByUser)
                    {{ $data->updatedByUser->name }} ({{ $data->updatedByUser->email }})
                @else
                    {{ $data->updated_by }}
                @endif
            </td>
        </tr>
    </tbody>
</table>
