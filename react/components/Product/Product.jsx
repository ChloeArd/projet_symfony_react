import "./Product.css";

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faHeart } from "@fortawesome/fontawesome-free-regular";

export const Product = function ({ product, setCartUpdated }) {

  async function handleClick(productId, amount) {
    await fetch("/api/cart/add", {
      method: "post",
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      "body": JSON.stringify({
        "product_id": productId,
        "quantity": amount,
      })
    });
    // Ici, je ne gère pas une réponse négative, ou une erreur libre à vous de créer un composant pour le faire
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
          {null !== setCartUpdated && (
            <div
              className={
                "QuantitySelector " +
                (parseInt(product.stock) === 0 ? " product-disabled" : "")
              }
            >
              <button className="less" onClick={handleClick(product.id, -1)}>
                -
              </button>
              <input type="number" value={product.cart} />
              <button className="add" onClick={handleClick(product.id, 1)}>
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
