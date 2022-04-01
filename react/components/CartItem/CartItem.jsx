import './CartItem.css';

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faTrashAlt } from '@fortawesome/fontawesome-free-regular';

export const CartItem = function ({product, setProducts}) {

    return (
        <div className="CartItem" id={product.id}>
            <div className="width_20">
                <p className="trash"><FontAwesomeIcon icon={faTrashAlt} /></p>
            </div>
            <div className="width_80_2">
                <div className="flexRow">
                    <p className="titleCartItem">{product.title}</p>
                    <span className="quantity">({product.cart})</span>
                </div>
                <div className="lineHorizontal"/>
            </div>
        </div>
    );
}