import './QuantitySelector.css';

export const QuantitySelector = function ({product, setIsProductUpdated}) {

    function handleMinusClick(e) {
        product.cart -= 1;
    }

    function handlePlusClick(e) {
        product.cart += 1;
    }

    return (
        <div className="QuantitySelector">
            <button className="less" onClick={handleMinusClick}> - </button>
            <input type="number" value={product.cart}/>
            <button className="add" onClick={handlePlusClick}> + </button>
        </div>
    );
}