const express = require('express')
const c = require('./db')
const app = express()
const port = 3000

app.get('/getAllSkuOffers/:sku', (req, res) => {
    const { sku } = req.params;
    console.log(`Getting data of sku: ${sku}`)
    const [ offers ] = c.DB_ROWS.filter(p => p.sku === sku)
    res.json(offers ?? { "error": "Not found valid offers" });
})

app.listen(port, () => {
   console.log(`Provider mock listening on port ${port}`)
})
