import React, { useEffect, useState } from 'react';

function Products() {
    const [products, setProducts] = useState([]);

    useEffect(() => {
        fetch('http://127.0.0.1:8000/api/products')
            .then(response => response.json())
            .then(data => setProducts(data))
            .catch(error => console.error('Błąd pobierania produktów:', error));
    }, []);

    return (
        <div>
            <h2>Lista produktów</h2>
            <ul>
                {products.map(product => (
                    <li key={product.produkt_id}>
                        {product.nazwa} - {product.parametr} - {product.cena_brutto} zł
                    </li>
                ))}
            </ul>
        </div>
    );
}

export default Products;
