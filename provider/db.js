module.exports = Object.freeze({
    DB_ROWS: [{
        "sku": "1000",
        "offers": [
            {
                "id": 1,
                "price": 10.00,
                "stock": 5,
                "shipping_price": 25.00,
                "delivery_date": "2023-05-27",
                "can_be_refunded": true,
                "status": "new",
                "guarantee": true,
                "seller": {
                    "name": "Seller 1",
                    "qualification": 0,
                    "reviews_quantity": 0
                }
            },{
                "id": 2,
                "price": 15.00,
                "stock": 0,
                "shipping_price": 5.00,
                "delivery_date": "2023-05-27",
                "can_be_refunded": true,
                "status": "new",
                "guarantee": true,
                "seller": {
                    "name": "Seller 2", 
                    "qualification": 0,
                    "reviews_quantity": 0
                }
            },{
                "id": 3,
                "price": 20.00,
                "stock": 2,
                "shipping_price": 2.00,
                "delivery_date": "2023-05-27",
                "can_be_refunded": true,
                "status": "new",
                "guarantee": true,
                "seller": {
                    "name": "Seller 2", 
                    "qualification": 0,
                    "reviews_quantity": 0
                }
            }
        ]
    }]
})