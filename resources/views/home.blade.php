@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <table class="table table-bordered" id="table">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Year</th>
                            <th>Poster</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
  $(function() {
    var dtable = $('#table').DataTable({
      processing: true,
      aaSorting:[0],
      bLengthChange:false,
      serverSide: true,
      ajax: {
        url: '{{ url('get-data') }}',
        error: function (xhr, error, code) {
          var result = $.parseJSON(xhr.responseText);
          $(".card-body").html(result.message);
        } 
      },
      columns: [
        { data: 'Title', name: 'Title' },
        { data: 'Type', name: 'Type' },
        { data: 'Year', name: 'Year' },
        { data: 'Poster', name: 'Poster', orderable: false, "render": function (data) {
            if(data != "N/A") {
              return "<img src=\"" + data + "\" height=\"50\"/>";
            } else {
              return "-";
            }
        }, }
      ]
    });
    $(".dataTables_filter input")
      .unbind() // Unbind previous default bindings
      .bind("keypress", function(e) { // Bind our desired behavior
        // If the length is 3 or more characters, or the user pressed ENTER, search
        if(this.value.length >= 3 && e.keyCode == 13) {
          // Call the API search function
          dtable.search(this.value).draw();
        }
        // Ensure we clear the search if they backspace far enough
        if(this.value == "") {
          dtable.search("").draw();
        }
        return;
      });
  });
</script>
@endsection
