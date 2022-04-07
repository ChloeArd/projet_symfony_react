import { useEffect, useState } from "react";
import { Cart } from "../components/Cart";
import { ProductList } from "../components/ProductList";
import {Categories} from "../components/Categories.jsx";
import styled from "styled-components";
import {CartContext} from "../context/CartContext";

export const Home = function () {
  const [category, setCategory] = useState(0);

  // set title
  useEffect(() => {document.title = "Accueil";}, []);

  return (
    <>
      <CartContext>
        <ContainerLeft>
          <Cart/>
          <ContainerRight>
            <Categories setCategory={setCategory} />
            <ProductList category={category} />
          </ContainerRight>
        </ContainerLeft>
      </CartContext>
    </>
  );
};

const ContainerLeft = styled.div`
  width: 80%;
  margin: 0 auto;
  padding: 40px;
  display: flex;
  flex-direction: row;
`;

const ContainerRight = styled.div`
  width: 80%;
  margin: 0 auto;
  padding: 40px;
`;
