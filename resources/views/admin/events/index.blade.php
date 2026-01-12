@extends('admin.template')
@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mb-4 ">Events List</h4>

                </div>
                <a href="{{ route('admin.events.create') }}" class="btn btn-primary mb-3 text-right">Add Event</a>

                <div clas="table-responsive">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($event->image && file_exists(public_path($event->image)))
                                    <img src="{{ asset('public/'.$event->image) }}" width="80">
                                    @else
                                    <span class="text-muted">No Image</span>
                                    @endif

                                </td>
                                <td>{{ $event->title }}</td>
                                <td>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</td>
                                <td>{{ $event->location }}</td>
                                <td>
                                    <span class="badge {{ $event->event_type == 'live' ? 'bg-danger' : 'bg-info' }}">
                                        {{ ucfirst($event->event_type) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.events.edit',$event->id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('admin.events.destroy',$event->id) }}"
                                        method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this event?')">
                                            Delete
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
</div>
@endsection