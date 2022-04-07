import {useEffect, useState} from "react";
import styled from "styled-components";
import {Product} from "./Product/Product";

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
        <ContainerProductList>
            {products
                .filter(product => category === 0 || product.category.id === category)
                .map(product => <CustomProduct key={product.id} product={product} setCartUpdated={setCartUpdated} />)}
        </ContainerProductList>
    );
}

const CustomProduct = styled(Product)`
    box-shadow: rgba(0, 0, 0, 0.15) 0 5px 15px 0;
`;

const ContainerProductList = styled.div`
    width: 100%;
    padding: 10px;
    margin: 15px;
`;