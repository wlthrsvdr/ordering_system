<table class="table table-bordered table-condensed table-striped table-hover mt-3">
    <thead>
        <tr>
            <th style="font-weight: bold">Transaction Number</th>
            <th style="font-weight: bold">Orders</th>
            <th style="font-weight: bold">Order By</th>
            <th style="font-weight: bold">Status</th>
            <th style="font-weight: bold">Order Date</th>
            <th style="font-weight: bold">Paid Date</th>
            <th style="font-weight: bold">Total Amount</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as  $value)
            <tr>
                <td width="20" style="text-align: center">
                    @if ($value->transaction_number)
                        <div class="mb5">
                            {{ $value->transaction_number }}
                        </div>
                    @else
                        <div class="mb5">{{ '-' }}</div>
                    @endif
                </td>
                <td width="40">
                    @if ($value->order)
                        @foreach ($value->order as $val)
                            {{ '- Product Name:' . ' ' . $val['product_name'] }}({{ $val['quantity'] }}x)<br>
                        @endforeach
                    @else
                        <div class="mb5">{{ '-' }}</div>
                    @endif
                </td>
                <td width="20">
                    @if ($value->orderBy->name)
                        <div class="mb5">
                            {{ $value->orderBy->name }}
                        </div>
                    @else
                        <div class="mb5">{{ '-' }}</div>
                    @endif
                </td>
                <td width="20">
                    <div class="mb5">
                        {{ $value->status }}
                    </div>
                </td>
                <td width="20">
                    @if ($value->created_at)
                        <div class="mb5">
                            {{ $value->created_at->format('m-d-Y') }}
                        </div>
                    @else
                        <div class="mb5">{{ '-' }}</div>
                    @endif
                </td>
                <td width="20">
                    @if ($value->paid_date)
                        <div class="mb5">
                            {{ $value->paid_date->format('m-d-Y') }}
                        </div>
                    @else
                        <div class="mb5">{{ '-' }}</div>
                    @endif
                </td>
                <td width="20">
                    @if ($value->total_amount)
                        <div class="mb5">
                            {{ $value->total_amount }}
                        </div>
                    @else
                        <div class="mb5">{{ '-' }}</div>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" width="20">
                    <p>No record found yet.</p>
                </td>
            </tr>
        @endforelse
        <tr>
            <td colspan="4" width="20" style="align-content: center; text-align:center">
                <div class="mb5">
                    <b> {{ 'TOTAL' }}</b>
                </div>
            </td>
            <td colspan='3' width='20' style="align-content: center; text-align:center">
                <b>{{ $grand_total }} </b>
            </td>
        </tr>
    </tbody>
</table>
