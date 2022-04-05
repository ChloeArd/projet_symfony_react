import "./Product.css";

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faHeart } from "@fortawesome/fontawesome-free-regular";
import {useState} from "react";

export const Product = function ({ product, setCartUpdated }) {

  const [stock, setStock] = useState(product.stock);

  /**
   * Handle click on + and - buttons
   * @param productId
   * @param amount
   * @returns {Promise<void>}
   */
  async function handleClick(productId, amount) {

    const fetchInit = {
      method: "post",
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json"
      }
    };

    await fetch("/api/cart/add", {
      ...fetchInit,
      "body": JSON.stringify({
        "product_id": productId,
        "quantity": amount,
      })
    });

    //Getting new product stock
    const response = await fetch("/api/product/stock", {
      ...fetchInit,
      body: JSON.stringify({
        product_id: productId
      })
    });

    const data = await response.json();
    setStock(data.stock);
    setCartUpdated(true);
  }

  return (
    <div className="Product" id={product.id}>
      <div className="image">
        <img src={require(`./../../../public/uploads/${product.image}`)} alt={product.name} />
      </div>
      <div className="content">
        <span className="favorite">
          <FontAwesomeIcon icon={faHeart} />
        </span>
        <h1>{product.name}</h1>
        <p className="description">{product.description}</p>
        <div className="flexRow">
          <p className="stock-status">En stock: <span>{stock}</span></p>
          {null !== setCartUpdated && (
            <div
              className={
                "QuantitySelector " +
                (parseInt(stock) === 0 ? " product-disabled" : "")
              }
            >
              <button className="less" onClick={() => handleClick(product.id, -1)}>
                -
              </button>
              <button className="add" onClick={() => handleClick(product.id, 1)}>
                +
              </button>
            </div>
          )}
          <p className="price">${product.price}</p>
        </div>
      </div>
    </div>
  );
};
