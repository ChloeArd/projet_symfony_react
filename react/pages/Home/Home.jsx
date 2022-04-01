import "./Home.css";

import { useEffect, useState } from "react";
import { Cart } from "../../components/Cart/Cart";
import { Categories } from "../../components/Categories/Categories";
import { ProductList } from "../../components/ProductList/ProductList";

export const Home = function () {
  const [products, setProducts] = useState([]);
  const [isProductUpdated, setIsProductUpdated] = useState(false);
  const [category, setCategory] = useState(0);
  const [categories, setCategories] = useState([[]]);
  const [factor, setFactor] = useState(0);

  useEffect(() => {
    document.title = "Accueil";
  }, []);

  useEffect(() => {
    setFactor(Math.floor(Math.random() * 100));
  }, [setFactor, category]);

  if (isProductUpdated) {
    setProducts(products);
    setIsProductUpdated(false);
  }

  return (
    <>
      <div className="width_80">
        <Cart products={products} setIsProductUpdated={setIsProductUpdated} />
        <div className="width_80_2">
          <Categories setCategory={setCategory} categories={categories} />
          <ProductList
            category={category}
            products={products}
            setIsProductUpdated={setIsProductUpdated}
          />
        </div>
      </div>
    </>
  );
};
