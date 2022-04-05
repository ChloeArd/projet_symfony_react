import "./Home.css";

import { useEffect, useState } from "react";
import { Cart } from "../../components/Cart/Cart";
import { Categories } from "../../components/Categories/Categories";
import { ProductList } from "../../components/ProductList/ProductList";

export const Home = function () {
  const [products, setProducts] = useState([]);
  const [cartUpdated, setCartUpdated] = useState(false);
  const [category, setCategory] = useState(0);
  // const [categories, setCategories] = useState([[]]);
  // const [factor, setFactor] = useState(0);


  useEffect(() => {

    //Avec XHR
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '/api/products');
    xhr.responseType = 'json';
    xhr.onload = () => {
      setProducts(xhr.response)
    };
    xhr.send();
  }, []);

  // set title
  useEffect(() => {
    document.title = "Accueil";
  }, []);

  // useEffect(() => {
  //   setFactor(Math.floor(Math.random() * 100));
  // }, [setFactor, category]);

  useEffect(() => {
    async function getProducts() {
      const response = await fetch('api/products');
      setProducts(await response.json());
    }
    getProducts().catch(() => console.log('Impossible de récupérer les produits'));
  }, [cartUpdated]);

  // if (cartUpdated) {
  //   setProducts(products);
  //   setCartUpdated(false);
  // }

  return (
    <>
      <div className="width_80">
        <Cart cartUpdated={cartUpdated} setCartUpdated={setCartUpdated} />
        <div className="width_80_2">
          <Categories setCategory={setCategory} />
          <ProductList
            category={category}
            products={products}
            setCartUpdated={setCartUpdated}
          />
        </div>
      </div>
    </>
  );
};
