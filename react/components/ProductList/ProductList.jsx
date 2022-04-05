import './ProductList.css';

import {Product} from "../Product/Product";
import {useEffect, useState} from "react";

export const ProductList = function ({category, setCartUpdated}) {
    const [products, setProducts] = useState([]);

    useEffect(() => {
        async function getProducts() {
            const response = await fetch('/api/products');
            setProducts(await response.json());
        }
        getProducts().catch(() => console.log('Impossible de récupérer les produits'));
    }, []);

    return(
        <div className="ProductList">
            {products
                .filter(product => category === 0 || product.category.id === category)
                .map(product => <Product key={product.id} product={product} setCartUpdated={setCartUpdated} />)}
        </div>
    );
}