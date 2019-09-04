@extends('layouts.main')

@section('title', 'Index')

@push('scripts')
    <script src="/js/jquery-3.4.1.min.js"></script>
    <script>
        let csrf = "{{ csrf_token() }}",
            xid = "{{ $id??'' }}";

        function load(){
            if (xid !== '') {
                window.history.replaceState('notes', 'Notes - Index', "/notes");
            }
            $.get( "/api", function( data ) {
                if (data !== '') {
                    let list = '';
                    $.each(data, function(i, d){
                        list += '<li><a href="javascript:void(0)" class="note" id="'+d.id+'">'+d.note.substr(0,120)+((d.note.length > 120)?'...':'')+'</a></li>';
                    });
                    $('.container').html('<ul class="notes">'+list+'</ul>');
                    $('.nav').html('<li><a href="javascript:void(0)" class="add" id="">Add New</a></li>');
                    $('.note').on('click', function(){
                        get(this.id);
                    });
                    $('.add').on('click', function(){
                        $('.container').html('<textarea id="note"></textarea>');
                        $('.nav').html(
                            '<li><a href="javascript:void(0)" class="cancel" id="">Cancel</a></li>'+
                            '<li><a href="javascript:void(0)" class="save">Save</a></li>'
                        );
                        $('.cancel').on('click', function(){
                            load();
                        });
                        $('.save').on('click', function(){
                            insert();
                        });
                    });
                } else {
                    $('.container').html('<p>No notes available</p>');
                }
            });
        }

        if (xid !== '') {
            get(xid);
        } else {
            load();
        }

        function get(id){
            xid = id;
            window.history.replaceState('notes', 'Notes - Index', "/notes/"+id);
            $.get( "/api/"+id, function( data ) {
                if (data !== '') {
                    $('.container').html('<pre>'+data.note+'</pre>');
                    $('.nav').html(
                        '<li><a href="javascript:void(0)" class="back" id="">Back</a></li>'+
                        '<li><a href="javascript:void(0)" class="edit" id="'+data.id+'">Edit</a></li>'
                    );
                    $('.back').on('click', function(){
                        load();
                    });
                    $('.edit').on('click', function(){
                        $('.container').html('<textarea id="note">'+data.note+'</textarea>');
                        $('.nav').html(
                            '<li><a href="javascript:void(0)" class="cancel" id="'+data.id+'">Cancel</a></li>'+
                            '<li><a href="javascript:void(0)" class="delete" id="'+data.id+'">Delete</a></li>'+
                            '<li><a href="javascript:void(0)" class="save" id="'+data.id+'">Save</a></li>'
                        );
                        $('.cancel').on('click', function(){
                            get(this.id);
                        });
                        $('.delete').on('click', function(){
                            del(this.id);
                        });
                        $('.save').on('click', function(){
                            update(this.id);
                        });

                    });

                }
            });
        }

        function del(id){
            if(confirm("are you sure?")) {
                $.ajax({url: '/api/' + id, type: 'DELETE', data: {_token: csrf}})
                    .done(function (data) {
                        //alert(JSON.parse(data).success);
                        load();
                    });
            }
        }

        function update(id){
            $.post( "/api/", { id: id, note: $('#note').val(), _token: csrf })
                .done(function(data) {
                    //alert( JSON.parse(data).success );
                    get(id);
            });
        }

        function insert(){
            $.ajax({ url: '/api/', type: 'PUT', data: { note: $('#note').val(), _token: csrf } })
                .done(function(data) {
                    //alert( JSON.parse(data).success );
                    load();
                });
        }
    </script>
@endpush

@section('header')
    @parent
        <ul class="nav"></ul>
@endsection

@section('content')

@endsection