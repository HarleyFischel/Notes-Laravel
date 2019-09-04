function Notes(props) {
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
);