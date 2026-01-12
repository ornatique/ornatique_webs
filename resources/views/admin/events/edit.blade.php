@extends('admin.template')

@section('main')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-3">Edit Event</h4>

                <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        {{-- Title --}}
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Event Title <span class="text-danger">*</span></label>
                                <input type="text" name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title', $event->title) }}">
                                @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Event Date --}}
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Event Date <span class="text-danger">*</span></label>
                                <input type="date" name="event_date"
                                    class="form-control @error('event_date') is-invalid @enderror"
                                    value="{{ old('event_date', $event->event_date) }}">
                                @error('event_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Location --}}
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" name="location"
                                    class="form-control @error('location') is-invalid @enderror"
                                    value="{{ old('location', $event->location) }}">
                                @error('location')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" rows="4"
                                    class="form-control @error('description') is-invalid @enderror">{{ old('description', $event->description) }}</textarea>
                                @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Image --}}
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Event Image</label><br>

                                @if($event->image)
                                <img id="preview-file" src="{{ asset('public/'.$event->image) }}" height="200" class="mb-2">
                                @else
                                <img id="preview-file" src="" height="200" class="mb-2 d-none">
                                @endif

                                <input type="file" name="image" id="image"
                                    class="form-control @error('image') is-invalid @enderror"
                                    accept="image/*">
                                @error('image')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Event Type --}}
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Event Type <span class="text-danger">*</span></label>
                                <select name="event_type"
                                    class="form-select @error('event_type') is-invalid @enderror">
                                    <option value="" disabled selected>-- Select Event Type --</option>
                                    <option value="upcoming" {{ old('event_type', $event->event_type) == 'upcoming' ? 'selected' : '' }}>
                                        Upcoming
                                    </option>
                                    <option value="live" {{ old('event_type', $event->event_type) == 'live' ? 'selected' : '' }}>
                                        Live
                                    </option>
                                </select>
                                @error('event_type')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                    </div>

                    <button type="submit" class="btn btn-success mt-2">Update</button>

                </form>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#image').change(function() {
            if (this.files && this.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-file').attr('src', e.target.result).removeClass('d-none');
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@stop