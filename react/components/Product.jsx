import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faHeart} from "@fortawesome/fontawesome-free-regular";
import {useState, useContext} from "react";
import styled from "styled-components";
import {darken, lighten} from "polished";
import {CartContextProvider} from "../context/CartContext";

export const Product = function ({className, product, }) {

    const [stock, setStock] = useState(product.stock);
    const {setCartUpdated} = useContext(CartContextProvider);

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
        <ContainerProduct id={product.id} className={className}>
            <div className="image">
                <img src={require(`./../../public/uploads/${product.image}`)} alt={product.name}/>
            </div>
            <Content>
                <span><FontAwesomeIcon icon={faHeart}/></span>
                <h1>{product.name}</h1>
                <p>{product.description}</p>
                <ContainerBottom>
                    <p className="stock-status">En stock: <span>{stock}</span></p>
                    {null !== setCartUpdated && (
                        <QuantitySelector stockValue={stock}
                                          className={
                                              (parseInt(stock) === 0 ? " product-disabled" : "")
                                          }
                        >
                            <MinusButton className="less" onClick={() => handleClick(product.id, -1)}/>
                            <PlusButton className="add" onClick={() => handleClick(product.id, 1)}/>
                        </QuantitySelector>
                    )}
                    <p className="price">${product.price}</p>
                </ContainerBottom>
            </Content>
        </ContainerProduct>
    );
};

const ContainerProduct = styled.div`
  width: 100%;
  padding: 20px;
  margin-bottom: 15px;
  border: 1px solid #F2F2F3;
  border-radius: 10px;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  background-color: white;

  &:hover {
    box-shadow: rgba(23, 38, 211, 0.48) 0 5px 15px 0;
  }

  & > .image {
    width: 25%;
    margin: auto;

    & > img {
      width: 100%;
      border-radius: 10px;
    }
  }
`;

const isLoaded = false;

const minusLightenLoaded = lighten(0.05, "#d9d9d9");
const minusLightenNotLoaded = "#dcdcdc"

const plusLighten = lighten(0.1, "#26447c")

const MinusButton = styled.button`
  background-color: #F3F4F6;
  font-size: 20px;
  border-radius: 5px;
  padding: 15px;
  border: none;
  margin: 0 5px;
  width: 34%;

  &:hover {
    background-color: ${isLoaded ? minusLightenLoaded : minusLightenNotLoaded};
  }

  &:before {
    content: "-";
  }
`;

const PlusButton = styled(MinusButton)`
  background-color: #1E64DD;
  color: white;

  &:hover {
    background-color: ${plusLighten};
  }

  &:before {
    content: "+";
  }
`;

const Content = styled.div`
  width: 70%;

  & > span {
    position: absolute;
    right: 11%;
    color: #BBC0C9;
    font-size: 20px;

    &:hover {
      color: ${lighten(0.05, "#C72C2C")};
    }
  }

  & > p {
    color: #2F3540;
  }
`;

const ContainerBottom = styled.div`
  display: flex;
  flex-direction: row;
  align-items: center;

  & > .price {
    font-size: 35px;
    font-weight: bold;
    position: absolute;
    right: 11%;
  }
`;

const colors = {
    primary: darken(10, "black"),
    secondary: "red"
}

const QuantitySelector = styled.div`
  font-size: 20px;
  padding: 5px;
  border: 1px solid #F2F2F3;
  border-radius: 5px;
  margin: 20px;
  width: 20%;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
  background-color: ${(stockValue) => stockValue === 0 ? "#e3e3e3" : "rgba(183,187,238,0.48)"};

  &.product-disabled {
    background-color: ${colors.primary};
  }
`;