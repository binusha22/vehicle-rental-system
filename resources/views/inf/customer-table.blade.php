<div class="table-responsive">
    <table class="table table-hover" id="customer_table">
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Id Number</th>
                <th>Passport Number</th>
                <th>Phone Number</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cus as $cs)
                <tr>
                    <td>{{ $cs->fname }} {{ $cs->lname }}</td>
                    <td>{{ $cs->idnumber }}</td>
                    <td>{{ $cs->passportnumber }}</td>
                    <td>{{ $cs->phonenumber }}</td>
                    <td>{{ $cs->regDate }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No customer found <a href="#"><b><span style="color:red;">Refresh</span></b></a></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
