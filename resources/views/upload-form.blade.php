
    <div class="container">

        <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">{{ __('home.Choose Excel File') }}</label>
                <input type="file" name="file" id="file" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">{{ __('home.Import') }}</button>
        </form>
    </div>
