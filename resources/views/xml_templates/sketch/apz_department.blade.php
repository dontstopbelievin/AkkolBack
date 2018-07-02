<root>
    <content>
        <user user_id="{{ $sketch->user->id }}">
            <name>{{ $sketch->user->name }}></name>
            <email>{{ $sketch->user->email }}</email>

            @if ($sketch->user->iin)
                <iin>{{ $sketch->user->iin }}</iin>
            @endif

            @if ($sketch->user->bin)
                <bin>{{ $sketch->user->bin }}</bin>
            @endif

            @if ($sketch->user->company_name)
                <company_name>{{ $sketch->user->company_name }}</company_name>
            @endif

            <created_at>{{ $sketch->user->created_at }}</created_at>
        </user>

        <sketch sketch_id="{{ $sketch->id }}">
            <region>{{ $sketch->region }}</region>
            <applicant>{{ $sketch->applicant }}</applicant>
            <customer>{{ $sketch->customer }}</customer>
            <address>{{ $sketch->address }}</address>
            <designer>{{ $sketch->designer }}</designer>
            <phone>{{ $sketch->phone }}</phone>
            <project_name>{{ $sketch->project_name }}</project_name>
            <project_address>{{ $sketch->project_address }}</project_address>
            <sketch_date>{{ $sketch->sketch_date }}</sketch_date>
            <created_at>{{ $sketch->created_at }}</created_at>
        </sketch>

        <apz_department_response response_id="{{ $sketch->apzDepartmentResponse->id }}">
            <response_text>{{ $sketch->apzDepartmentResponse->response_text }}</response_text>
            <response>{{ $sketch->apzDepartmentResponse->response }}</response>
            <created_at>{{ $sketch->apzDepartmentResponse->created_at }}</created_at>
        </apz_department_response>

        <apz_department_info response_id="{{ $user->id }}">
            <name>{{ $user->name }}</name>
            <email>{{ $user->email }}</email>

            @if ($user->iin)
                <iin>{{ $user->iin }}</iin>
            @endif

            @if ($user->bin)
                <bin>{{ $user->bin }}</bin>
            @endif

            <created_at>{{ $user->created_at }}</created_at>
        </apz_department_info>
    </content>
</root>