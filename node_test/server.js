
const express = require('express');
const app = express();
const port = 80;
const path = require('path');

app.use(express.static('/'));

app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, '..', '/app/views/index.html'));
});

app.listen(port, () => console.log(`Example app listening on port ${port}!`));