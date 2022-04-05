import './ProductList.css';

import {Product} from "../Product/Product";

export const ProductList = function ({category, products, setCartUpdated}) {

    return(
        <div className="ProductList">
            {products
                .filter(product => category === 0 || product.category === category)
                .map(product => <Product key={product.id} product={product} setCartUpdated={setCartUpdated} />)}
        </div>
    );
}