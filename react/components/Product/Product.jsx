import "./Product.css";

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faHeart } from "@fortawesome/fontawesome-free-regular";

export const Product = function ({ product, setIsProductUpdated = null }) {
  function handleMinusClick(e) {
    if (product.cart > 0) {
      product.cart -= 1;
      setIsProductUpdated(true);
    }
  }

  function handlePlusClick(e) {
    if (product.cart < product.stock) {
      product.cart += 1;
      setIsProductUpdated(true);
    }
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
        <h1>{product["title"]}</h1>
        <p className="description">{product.description}</p>
        <div className="flexRow">
          {null !== setIsProductUpdated && (
            <div
              className={
                "QuantitySelector " +
                (parseInt(product.stock) === 0 ? " product-disabled" : "")
              }
            >
              <button className="less" onClick={handleMinusClick}>
                -
              </button>
              <input type="number" value={product.cart} />
              <button className="add" onClick={handlePlusClick}>
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
