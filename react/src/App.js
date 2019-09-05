import React from 'react';
import ReactDOM from 'react-dom';
import './App.css';

let url = document.location.href.split('/');

let csrf = "",
    headers = {
        'X-CSRF-TOKEN': csrf,
        'Content-Type': 'application/json'
    },
    xid = (Number.isInteger(parseInt(url[url.length-1])))?url[url.length-1]:'';


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
                <ul className="notes">
                    {items.map(i => (
                        <li key={i.id} className="link" onClick={(id) => openNote(i.id)}>{i.note.substr(0,120)}{i.note.length > 120?'...':''}</li>
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
        const { error, isLoaded, item } = this.state;
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
        const {error, isLoaded, item} = this.state;
        if (error) {
            return <div>Error: {error.message}</div>;
        } else if (!isLoaded) {
            return <div>Loading...</div>;
        } else {
            return (
                <textarea id="note" defaultValue={item.note}></textarea>
            );
        }
    }
}

function listNotes() {
    if (xid !== '') {
        window.history.replaceState('', 'Notes - Index', "/");
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
    window.history.replaceState('', 'Notes - Index', "/"+id);

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

function token() {
    fetch("http://localhost:8000/api/token/")
        .then(res => res.json())
        .then(
            (result) => {
                csrf = result.token;
                headers = {
                    'X-CSRF-TOKEN': csrf,
                    'Content-Type': 'application/json'
                };
            }
        )
}

function list(i) {
    fetch("http://localhost:8000/api/")
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
    fetch("http://localhost:8000/api/"+i.state.id)
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
    fetch('http://localhost:8000/api/', {
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
    fetch('http://localhost:8000/api/', {
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
    //if(confirm("are you sure?")) {
        fetch('http://localhost:8000/api/' + id, { method: 'DELETE', headers: headers })
            .then(res => res.json())
            .then((result)=>{
                //alert( result.success );
                listNotes();
            });
    //}
}


function App() {
  return (
    <div className="App">
        <div className="header">
            <h2 className="title">My Notes</h2>
            <ul id="nav" className="nav"></ul>
        </div>

        <div className="container">
            <div id="notes"></div>
        </div>

    </div>
  );
}

export default App;

/*function run() {
    ReactDOM.render(<App />, document.getElementById('app'));
}*/
document.addEventListener("DOMContentLoaded", function () {
    token();

    if (xid !== '') {
        openNote(xid);
    } else {
        listNotes();
    }

//    listNotes();
});
