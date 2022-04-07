import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faTrashAlt } from '@fortawesome/fontawesome-free-regular';
import styled from "styled-components";

export const CartItem = function ({cartItem}) {

    async function deleteOneCartClick() {
        console.log(cartItem.id);
    }

    return (
        <ContainerCartItem id={cartItem.product.id}>
            <CartItemLeft>
                <p onClick={deleteOneCartClick} className="trash"><FontAwesomeIcon icon={faTrashAlt} /></p>
            </CartItemLeft>
            <CartItemRight>
                <div>
                    <p>{cartItem.product.name}</p>
                    <span>({cartItem.quantity})</span>
                </div>
                <LineHorizontal />
            </CartItemRight>
        </ContainerCartItem>
    );
}

const ContainerCartItem = styled.div`
    display: flex;
    flex-direction: row;
    align-items: center;
    width: 100%;
    
    &:hover {
        color: #ffc74b;
    }
`;

const CartItemLeft = styled.div`
    width: 20%;
    text-align: center;
    
    & > p {
        color: #1E64DD;
        margin-right: 10px;
        font-size: 20px;
        padding-bottom: 15px;
        
        &:hover {
         color: #C72C2C;
        }
    }
`;

const CartItemRight = styled.div`
    width: 80%;
    margin: 0 auto;
    padding: 0;
    padding-bottom: 15px;
    
    & > div {
        display:flex;
        flex-direction: row;
        align-items: center;
    
        & > p {
            font-size: 20px;
        }
        
        & > span {
            font-size: 20px;
            position: absolute;
            left: 26%;
        }
    }
`;

const LineHorizontal = styled.div`
    border-bottom: 1px solid #BBC0C9;
    width: 100%;
`;