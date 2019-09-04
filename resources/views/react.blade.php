@extends('layouts.main')

@section('title', 'Index')

@push('scripts')
    <script src="/js/react.production.min.js"></script>
    <script src="/js/react-dom.production.min.js"></script>
    <script src="/js/babel.min.js"></script>

    <script type="text/babel"> // type="text/jsx">

        let csrf = "{{ csrf_token() }}",
            headers = {
                'X-CSRF-TOKEN': csrf,
                'Content-Type': 'application/json'
            },
            xid = "{{ $id??'' }}";

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
                            <li className="link" onClick={(id) => openNote(i.id)}>{i.note.substr(0,120)}{i.note.length > 120?'...':''}</li>
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
                    <textarea id="note"></textarea>
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
                        <textarea id="note">{item.note}</textarea>
                    );
                }
            }
        }

        function listNotes() {
            if (xid !== '') {
                window.history.replaceState('react', 'Notes - Index', "/react");
            }

            ReactDOM.render(
                <li className="link" onClick={addNote}>Add New</li>,
                document.getElementById('nav')
            );

            ReactDOM.render(
                <Notes />,
                document.getElementById('notes')
            );
        }

        function openNote(id) {
            xid = id;
            window.history.replaceState('react', 'Notes - Index', "/react/"+id);
            ReactDOM.render((
                <span>
            <li className="link" onClick={listNotes}>Back</li>
            <li className="link" onClick={(eid) => editNote(id)}>Edit</li>
        </span>
            ), document.getElementById('nav'));

            ReactDOM.render(
                <Note id={id} />,
                document.getElementById('notes')
            );
        }

        function addNote() {
            ReactDOM.render((
                    <span>
                    <li className="link" onClick={listNotes}>Cancel</li>
                    <li className="link" onClick={insert}>Save</li>
                </span>
                ), document.getElementById('nav')
            );
            ReactDOM.render(
                <New />,
                document.getElementById('notes')
            );
        }

        function editNote(id) {
            ReactDOM.render((
                <span>
            <li className="link" onClick={(oid) => openNote(id)}>Cancel</li>
            <li className="link" onClick={(did) => del(id)}>Delete</li>
            <li className="link" onClick={(uid) => update(id)}>Save</li>
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
            fetch('/api/', {
                method: 'PUT', headers: headers,
                body: JSON.stringify({ note: document.getElementById('note').value }),
            })
                .then(res => res.json())
                .then((result)=>{
                    //alert( result.success );
                    listNotes();
                });
        }

        function update(id) {
            fetch('/api/', {
                method: 'POST', headers: headers,
                body: JSON.stringify({ id: id, note: document.getElementById('note').value }),
            })
                .then(res => res.json())
                .then((result)=>{
                    //alert( result.success );
                    openNote(id);
                });
        }

        function del(id) {
            if(confirm("are you sure?")) {
                fetch('/api/' + id, { method: 'DELETE', headers: headers })
                    .then(res => res.json())
                    .then((result)=>{
                        //alert( result.success );
                        listNotes();
                    });
            }
        }

        if (xid !== '') {
            openNote(xid);
        } else {
            listNotes();
        }

    </script>
@endpush

@section('header')
    @parent
        <ul id="nav" class="nav"></ul>
@endsection

@section('content')
    <div id="notes"></div>
@endsection