{{-- <style>
    .text-center {
        text-align: center;
    }

    .table {
        /* width: 700px; */
        font-family: 'Verdana';
        border: 0.5px solid #cccccc;
    }

    table td,
    th {
        padding: 7px 10px;
        font-size: 15px;
        border: 1px solid;
    }

    .size {
        height: 213px;
        width: 224px;
    }

    .d-inline-block {
        display: inline-block;
    }

    .me-2 {
        margin-right: 3px;
    }

    .text-white {
        color: #ffffff;
    }

    .bg-dark {
        background-color: #000000;
    }
</style> --}}
{{-- @foreach ($products as $product) --}}
{{-- <div class="text-center size d-inline-block me-2">
        <table class="table size" cellspacing="0">
            <tr class="text-center">
                <td>
                    {{ \QrCode::size(100)->generate($product->id) }}
                </td>
            </tr>
            <tr class="text-center text-white bg-dark">
                <td> {{ ucfirst($product->name) }}</td>
            </tr>
            <tr class="text-center">
                <td>Wt : {{ $product->weight }}</td>
            </tr>
            <tr class="text-center">
                <td>Size : {{ $product->size }}</td>
            </tr>
        </table> --}}
{{-- <h1>Product Name : {{ $name }}</h1> --}}
{{-- </div> --}}
{{-- @endforeach --}}

{{-- <script src="{{ asset('public/assets/admin/libs/jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        window.print();
    })
</script> --}}


<style>
    .text-center {
        text-align: center;
    }


    .table {
        /* width: 700px; */
        font-family: 'Verdana';
        /* border: 0.1px solid #cccccc; */
    }

    table td,
    th {
        padding: 0;
        font-size: 4px;
        border: 0.1px solid;
    }

    .size {
        /* height: 129.21px; */
        /* width: 237.76px; */
        height: 45px;
        width: 80px;
        box-sizing: border-box;
    }

    .font-big {
        font-size: 9px;
        font-weight: bold;
    }

    .red {
        color: red;
    }
</style>
@foreach ($products as $product)
    <div class="size text-center" style="display: inline-block">
        {{-- <div class="float-start">{{ \QrCode::size(100)->generate($product->id) }}</div>
    <div class="float-end">
        <p>{{ ucfirst($product->name) }}</p>
        <p>Wt : {{ $product->weight }}</p>
        <p>Size : {{ $product->size }}</p>
    </div> --}}
        {{-- <table class="table size" cellspacing="0">
        <tr class="text-center">
            <td>
                {{ \QrCode::size(100)->generate($product->id) }}
            </td>
        </tr>
        <tr class="text-center">
            <td> {{ ucfirst($product->name) }}</td>
        </tr>
        <tr class="text-center">
            <td>Wt : {{ $product->weight }}</td>
        </tr>
        <tr class="text-center">
            <td>Size : {{ $product->size }}</td>
        </tr>
    </table> --}}
        <div></div>
        <table class="table size" cellspacing="0" cellpadding="0" style="margin: 2px">
            <tr class="text-enter">
                <td rowspan="3" cellspacing="0" cellpadding="0"
                    style="width: 50%;border:0.1px solid red;border-right:0;">
                    <div class="text-center">
                        {{ \QrCode::size(35)->generate($product->id) }}
                    </div>
                </td>
                @php
                    $numbers = preg_replace('/[^0-9]/', '', $product->name);
                    $letters = preg_replace('/[^a-zA-Z]/', '', $product->name);
                @endphp
                <td cellspacing="0" cellpadding="0" class="text-center" style="border-bottom: 0">
                    <span class="font-big" style="color: black">{{ strtoupper($letters) }}</span>
                    <span class="font-big red">{{ $numbers }}</span>
                </td>
            </tr>
            <tr>
                <td cellspacing="0" cellpadding="0" style="border-bottom: 0">
                    <span>Wt:<br></span>
                    <span class="font-big red"
                        style="text-align: right;display:block">{{ $product->weight}}
                    </span>
                </td>
            </tr>
            <tr>
                <td cellspacing="0" cellpadding="0">
                    <span>Size:<br></span>
                    <div style="text-align: right">
                        <span class="font-big red">{{ $product->size }}</span>
                        <span><b>mm</b></span>
                    </div>
                </td>
            </tr>
        </table>
        {{-- <h1>Product Name : {{ $name }}</h1> --}}
    </div>
@endforeach
<script src="{{ asset('public/assets/admin/libs/jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        window.print();
    })
</script>
