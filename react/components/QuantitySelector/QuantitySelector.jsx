import './QuantitySelector.css';

export const QuantitySelector = function ({product, setIsProductUpdated}) {

    function handleMinusClick(e) {
        product.stock -= 1;
    }

    function handlePlusClick(e) {
        product.stock += 1;
    }

    return (
        <div className="QuantitySelector">
            <button className="less" onClick={handleMinusClick}> - </button>
            <input type="number" value={product.stock}/>
            <button className="add" onClick={handlePlusClick}> + </button>
        </div>
    );
}