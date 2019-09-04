@extends('layouts.main')

@section('title', 'Index')

@push('scripts')
    <script src="/js/jquery-3.4.1.min.js"></script>
    <!-- script src="/js/react.development.js"></script>
    <script src="/js/react-dom.development.js"></script -->

    <script src="/js/react.production.min.js"></script>
    <script src="/js/react-dom.production.min.js"></script>

    <!-- script src="https://unpkg.com/react@16/umd/react.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js" crossorigin></script -->

    <script src="/js/babel.min.js"></script>

    <!-- script type="text/jsx" src="/js/react/list.js"></script -->

    <!-- script -->
    <script type="text/babel"> // type="text/jsx">

        class Notes extends React.Component {
            constructor(props) {
                super(props);
                this.state = {
                    error: null,
                    isLoaded: false,
                    items: []
                };
            }

            componentDidMount() {
                list(this)
            }

            render() {
                const { error, isLoaded, items } = this.state;
                if (error) {
                    return <div>Error: {error.message}</div>;
                } else if (!isLoaded) {
                    return <div>Loading...</div>;
                } else {
                    return (
                        <ul class="notes">
                        {items.map(i => (
                            <li><a href="javascript:void(0)" onClick={(id) => openNote(i.id)} id="{i.id}">{i.note.substr(0,120)}</a></li>
                ))}
                </ul>
                );
                }
            }
        }

        class Note extends React.Component {
            constructor(props) {
                super(props);
                this.state = {
                    error: null,
                    isLoaded: false,
                    id: props.id,
                    item: []
                };
            }

            componentDidMount() {
                get(this)
            }

            render() {
                const { error, isLoaded, id, item } = this.state;
                if (error) {
                    return <div>Error: {error.message}</div>;
                } else if (!isLoaded) {
                    return <div>Loading...</div>;
                } else {
                    return (
                        <pre>{item.note}</pre>
                    );
                }
            }
        }

        class New extends React.Component {
            render() {
                return (
                    <span>
                        @csrf</input>
                        <textarea id="note"></textarea>
                        <button onClick={insert} class="save">Save</button>
                    </span>
                );
            }
        }

        class Edit extends React.Component {
            constructor(props) {
                super(props);
                this.state = {
                    error: null,
                    isLoaded: false,
                    id: props.id,
                    item: []
                };
            }

            componentDidMount() {
                get(this)
            }

            render() {
                const {error, isLoaded, id, item} = this.state;
                if (error) {
                    return <div>Error: {error.message}</div>;
                } else if (!isLoaded) {
                    return <div>Loading...</div>;
                } else {
                    return (
                        <span>
                            @csrf</input>
                        <textarea id="note">{item.note}</textarea>
                        <button onClick={(id) => update(item.id)}> Save </button>
                        </span>
                    );
                }
            }
        }

        function listNotes() {
            ReactDOM.render(
                <li><a href="javascript:void(0)" onClick={addNote}>Add New</a></li>,
                document.getElementById('nav')
            );

            ReactDOM.render(
                <Notes />,
                document.getElementById('notes')
            );
        }

        function openNote(id) {
            ReactDOM.render((
                <span>
                        <li><a href="javascript:void(0)" onClick={listNotes}>Back</a></li>
                        <li><a href="javascript:void(0)" onClick={(eid) => editNote(id)}>Edit</a></li>
                        </span>
            ), document.getElementById('nav'));

            ReactDOM.render(
                <Note id={id} />,
                document.getElementById('notes')
            );
        }

        function addNote() {
            ReactDOM.render(
                <li><a href="javascript:void(0)" onClick={listNotes}>Cancel</a></li>,
                document.getElementById('nav')
            );
            ReactDOM.render(
                <New />,
                document.getElementById('notes')
            );
        }

        function editNote(id) {
            ReactDOM.render((
                <span>
                        <li><a href="javascript:void(0)" onClick={(oid) => openNote(id)}>Cancel</a></li>
                        <li><a href="javascript:void(0)" onClick={(did) => del(id)}>Delete</a></li>
                        </span>
            ), document.getElementById('nav'));

            ReactDOM.render(
                <Edit id={id} />,
                document.getElementById('notes')
            );
        }

        function list(i) {
            fetch("/api")
                .then(res => res.json())
                .then(
                    (result) => {
                        i.setState({
                            isLoaded: true,
                            items: Array.from(Object.keys(result), k=>result[k])
                        });
                    },
                    (error) => {
                        i.setState({
                            isLoaded: true,
                            error
                        });
                    }
                )
        }

        function get(i) {
            fetch("/api/"+i.state.id)
                .then(res => res.json())
                .then(
                    (result) => {
                        i.setState({
                            isLoaded: true,
                            item: result
                        });
                    },
                    (error) => {
                        i.setState({
                            isLoaded: true,
                            error
                        });
                    }
                )
        }

        function insert() {
/*            fetch('/api/', {method: 'PUT', body: JSON.stringify({ note: $('#note').val(), token: $("input[name='_token']").val() })})
                .then(res => res.json())
                .then((data)=>{
                    alert( JSON.parse(data).success );
                    listNotes();
                });
*/
            $.ajax({ url: '/api/', type: 'PUT', data: { note: $('#note').val(), _token: $("input[name='_token']").val() } })
                .done(function(data) {
                    alert( JSON.parse(data).success );
                    listNotes();
                });
        }

        function update(id) {
/*            let params = {
                method: 'POST',
                body: JSON.stringify({ id: id, note: $('#note').val(), _token: $("input[name='_token']").val() }),
//                headers: { 'content-Type': 'application/json' }
//                credentials: 'same-origin'
            };
            console.log(params);
            fetch('/api/', params)
                .then(res => res.json())
                .then((data)=>{
                    alert( JSON.parse(data).success );
                    listNotes();
                });
*/
            $.post( "/api/", { id: id, note: $('#note').val(), _token: $("input[name='_token']").val() })
                .done(function(data) {
                    alert( JSON.parse(data).success );
                    openNote(id);
                });
        }

        function del(id) {
            $.ajax({ url: '/api/'+id, type: 'DELETE', data: { _token: $("input[name='_token']").val() } })
                .done(function(data) {
                    alert( JSON.parse(data).success );
                    listNotes();
                });
        }

        listNotes();

        /*

        this.editClick = this.editClick.bind(this);
            editClick(id) {
                ReactDOM.render(
                    <Edit id={id} />,
                    document.getElementById('notes')
                );
            }



        class Clock extends React.Component {
            constructor(props) {
                super(props);
                this.state = {date: new Date()};
            }

            componentDidMount() {
                this.timerID = setInterval(
                    () => this.tick(),
                    1000
                );
            }

            componentWillUnmount() {
                clearInterval(this.timerID);
            }

            tick() {
                this.setState({
                    date: new Date()
                });
            }

            render() {
                return (
                    <div>
                        <h1>Hello, world!</h1>
                        <h2>It is {this.state.date.toLocaleTimeString()}.</h2>
                    </div>
                );
            }
        }
*/
/*        ReactDOM.render(
            <Clock />,
            document.getElementById('clock')
        );
*/
/*        function Notes(props) {
            const navbar = (
                <ul>
                    {props.notes.map((note) =>
                        <li key={note.id}>
                            {note.note}
                        </li>
                    )}
                </ul>
            );
            const content = props.notes.map((note) =>
                <div key={note.id}>
                    <pre>{note.note}</pre>
                </div>
            );
            return (
                <div>
                    {navbar}
                    <hr />
                    {content}
                </div>
            );
        }

        const notes = [
            {id: 1, note: 'Welcome to learning React!'},
            {id: 2, note: 'You can install React from npm.'}
        ];

        ReactDOM.render(
            <Notes notes={notes} />,
            document.getElementById('root')
        );*/
        /*        function load(){
            $.get( "/api", function( data ) {
                if (data !== '') {
                    let list = '';
                    $.each(JSON.parse(data), function(i, d){
                        list += '<li><a href="javascript:void(0)" class="note" id="'+d.id+'">'+d.note.substr(0,120)+((d.note.length > 120)?'...':'')+'</a></li>';
                    });
                    $('.container').html('<ul class="notes">'+list+'</ul>');
                    $('.nav').html('<li><a href="javascript:void(0)" class="add" id="">Add New</a></li>');
                    $('.note').on('click', function(){
                        get(this.id);
                    });
                    $('.add').on('click', function(){
                        $('.container').html('@csrf<textarea id="note"></textarea> <button class="save">Save</button>');
                        $('.nav').html('<li><a href="javascript:void(0)" class="cancel" id="">Cancel</a></li>');
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

        load();

        function get(id){
            $.get( "/api/"+id, function( data ) {
                if (data !== '') {
                    data = JSON.parse(data);
                    $('.container').html('<pre>'+data.note+'</pre>');
                    $('.nav').html(
                        '<li><a href="javascript:void(0)" class="back" id="">Back</a></li>'+
                        '<li><a href="javascript:void(0)" class="edit" id="'+data.id+'">Edit</a></li>'
                    );
                    $('.back').on('click', function(){
                        load();
                    });
                    $('.edit').on('click', function(){
                        $('.container').html('@csrf<textarea id="note">'+data.note+'</textarea> <button class="save" id="'+data.id+'">Save</button>');
                        $('.nav').html(
                            '<li><a href="javascript:void(0)" class="cancel" id="'+data.id+'">Cancel</a></li>'+
                            '<li><a href="javascript:void(0)" class="delete" id="'+data.id+'">Delete</a></li>'
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
            $.ajax({ url: '/api/'+id, type: 'DELETE', data: { _token: $("input[name='_token']").val() } })
                .done(function(data) {
                    alert( JSON.parse(data).success );
                    load();
                });
        }

        function update(id){
            $.post( "/api/", { id: id, note: $('#note').val(), _token: $("input[name='_token']").val() })
                .done(function(data) {
                    alert( JSON.parse(data).success );
                    get(id);
            });
        }

        function insert(){
            $.ajax({ url: '/api/', type: 'PUT', data: { note: $('#note').val(), _token: $("input[name='_token']").val() } })
                .done(function(data) {
                    alert( JSON.parse(data).success );
                    load();
                });
        }
        */
    </script>
@endpush

@section('header')
    @parent
        <ul id="nav" class="nav">
            <li><a href="/new">Add New</a></li>
        </ul>
@endsection

@section('content')
    <div id="clock"></div>
    <div id="notes"></div>
@endsection