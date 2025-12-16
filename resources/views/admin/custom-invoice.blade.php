<style>
    .table {
        width: 700px;
        font-family: 'Verdana';
        border: 0.5px solid #cccccc;
    }

    table td,
    th {
        padding: 7px 10px;
        font-size: 15px;
        border: 0.1px solid #cccccc;
    }

    .text-left {
        text-align: left;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    p {
        margin-bottom: 5px;
        margin-top: 0px;
        font-size: 14px
    }

    .border-bottom {
        border-bottom: 1px solid #cccccc
    }

    .border-left {
        border-left: 1px solid #cccccc
    }

    .border-0 {
        border: unset !important
    }

    .container {
        margin: 0 auto;
    }
</style>
<div class="container">
    <table class="table" cellspacing="0">
        <tr>
            <td colspan="7" class="border-bottom text-center">
                <p style="margin: 0"><b>Custom Estimate </b> </p>
            </td>
        </tr>
        <tr>
            <td colspan="7" class="border-bottom text-center">
                <h2 style="margin: 0">Estimate</h2>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="border-0">
                {{-- <p>
                    <b>Order ID:</b> {{ $order_id->order_id }}
                </p> --}}
                <p>
                    <b>Customer Name:</b> {{ $data->user ? ucfirst($data->user->name) : '' }}
                </p>
                {{-- <p>
                <b>Distributor Name:</b> Harsh Shah
            </p> --}}
                <p>
                    <b>Date:</b> {{ date('d/m/Y', strtotime($data->created_at)) }} |
                    <b>Time:</b> {{ date('h:i', strtotime($data->created_at)) }}
                </p>
            </td>
            {{-- <td colspan="3" class="border-0 text-right"><img
                    src="{{ asset('public/assets/admin/images/logo-dark.png') }}" width="250"></td> --}}
        </tr>
        <tr>
            <th class="text-center">Sr</th>
            <th class="text-center">Image</th>
            <th class="text-center">Description</th>
            {{-- <th class="text-center">Hole Size</th> --}}
            <th class="text-center">Remarks</th>
            {{-- <th class="text-center">Qty.</th> --}}
            {{-- <th class="text-center">Total <br> Weight</th> --}}
        </tr>
        @php
            $total_weight = 0;
        @endphp
        {{-- @foreach ($data as $i => $key) --}}
        <tr>
            <td class="text-center">{{ 1 }}</td>
            {{-- <td class="text-center"><img width="100"
                    src="{{ asset('public/assets/admin/images/products/img-1.png') }}">
            </td> --}}
            <td class="text-center"><img width="100"
                    src="{{ asset('public/assets/images/custom') . '/' . $data->image }}">
            </td>
            <td class="text-center">{{ $data->description }}</td>
            {{-- <td class="text-center">{{ $key->product->hole_size }}</td> --}}
            <td class="text-center">{{ $data->remarks }}</td>
            {{-- <td class="text-center">{{ $key->quantity }}</td> --}}
            {{-- <td class="text-center">{{ $key->quantity *  number_format((float)$key->product->weight, 3, '.', '') }}</td> --}}
            @php
                // $total_weight += $key->quantity * $key->product->weight;
            @endphp
        </tr>
        {{-- @endforeach --}}

        {{-- <tr>
            <td class="" colspan="4"><b>Approx Weight</b></td>
            <td class="text-center">{{ $total_quantity->total_quantity }}</td>
            <td class="text-center">{{   number_format((float)$total_weight, 3, '.', '');  }}</td>
        </tr> --}}
    </table>
</div>
<script src="{{ asset('public/assets/admin/libs/jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        window.print();
    })
</script>
