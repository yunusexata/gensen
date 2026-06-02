<div class="row">
    <div class="col-auto">
        <label for="">Status</label>
        <select class="form-control" wire:model.live="status">
            <option value="">-- SEMUA --</option>
            @foreach ($status_choice as $item)
                <option value="{{ $item }}">{{$item}}</option>
            @endforeach
        </select>
    </div>
</div>