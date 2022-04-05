import "./Home.css";

import { useEffect, useState } from "react";
import { Cart } from "../../components/Cart/Cart";
import { Categories } from "../../components/Categories/Categories";
import { ProductList } from "../../components/ProductList/ProductList";

export const Home = function () {
  const [cartUpdated, setCartUpdated] = useState(false);
  const [category, setCategory] = useState(0);

  // set title
  useEffect(() => {document.title = "Accueil";}, []);

  return (
    <>
      <div className="width_80">
        <Cart cartUpdated={cartUpdated} setCartUpdated={setCartUpdated} />
        <div className="width_80_2">
          <Categories setCategory={setCategory} />
          <ProductList
            category={category}
            setCartUpdated={setCartUpdated}
          />
        </div>
      </div>
    </>
  );
};
