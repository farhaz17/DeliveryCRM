<table class="table table-sm table-hover text-11">
    <thead>
        <tr>
            <th>Rider Name</th>
            @foreach ($performance_setting->column_settings as $column)
                <th>{{ $column['label'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($selected_date_wise_performances as $performance)
        <tr>
            <td>{{ $performance->passport->personal_info->full_name ?? "NA" }}</td>
            @foreach ($performance_setting->column_settings as $column)
                <td>{{ $performance[$column['name']] }} | {{ get_column_performace($column, $performance[$column['name']]) }}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
