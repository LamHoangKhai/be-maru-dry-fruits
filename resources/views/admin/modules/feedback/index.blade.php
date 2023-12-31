@extends('admin.master')
@push('css')
    <style>
        .pagi-right nav {
            display: flex;
            justify-content: end;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Other /</span>
                    Feedback
                </h4>

            </div>

            <div class="card">


                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table  table-bordered ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Date</th>

                                    <th class="max-110">Action</th>
                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0" id="renderData">
                                @if (!count($feedbacks))
                                    <tr>
                                        <td valign="top" colspan="7" class="text-center">No matching records found</td>
                                    </tr>
                                @endif

                                @foreach ($feedbacks as $feedback)
                                    <tr>
                                        <td>{{ $loop->iteration }} </td>
                                        <td>{{ $feedback->full_name }}</td>
                                        <td>{{ $feedback->email }}</td>
                                        <td class="">{{ $feedback->phone }}</td>
                                        <td>{{ date('Y/m/d H:i:s', strtotime($feedback->created_at)) }}</td>

                                        <td style="width: 200px">
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#exLargeModal{{ $loop->iteration }}">
                                                Detail
                                            </button>



                                        </td>
                                        @include('admin.modules.feedback.modal')
                                    </tr>
                                @endforeach

                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Date</th>
                                    <th class="max-110">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="card mt-4  pagi-right"> {{ $feedbacks->links() }} </div>
                </div>

            </div>



        </div>
    </div>

    <!-- /.card -->
@endsection
