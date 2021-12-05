<div class="dropdown dropleft text-right w-50 float-right">
    <button class="btn btn-link text-white"
        id="dropdownMenuButton1"
        type="button"
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false"
        ><i class="nav-icon i-Download"></i>
    </button>
    <div class="dropdown-menu"
        aria-labelledby="dropdownMenuButton1"
        x-placement="left-start"
        style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(241px, 0px, 0px);">
        @forelse ($file_paths as $time_sheet)
            <a class="dropdown-item" target="_blank" href="{{ Storage::temporaryUrl($time_sheet->uploaded_file_path, now()->addMinutes(5)) }}">
                {{ dateToRead($time_sheet->start_date) }}
            </a>
            @empty
            <a class="dropdown-item" href="#">
                No file Available
            </a>
        @endforelse
    </div>
</div>
