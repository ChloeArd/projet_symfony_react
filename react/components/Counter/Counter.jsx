import "./Counter.css";

import {useEffect, useState} from "react";

export const Counter = function ({factor}) {

    const [count, setCount] = useState(0);

    useEffect(() => {
        document.title = "Compteur: " + count;
    }, [count]);

    useEffect(() => {
        console.log("Debug, factor vaut: " + factor);
    }, [factor]);

    return(
        <div className="counter">
            <div>
                <button className="buttonCounter" onClick={() => setCount(count + factor)}>+{factor}</button>
                <button className="buttonCounter" onClick={() => setCount(count - factor)}>-{factor}</button>
                <button className="buttonCounter" onClick={() => setCount(count * factor)}>x{factor}</button>
                <button className="buttonCounter" onClick={() => setCount(count / factor)}>/{factor}</button>
            </div>
            <p>Compteur: {count}</p>
            <p>Facteur: {factor}</p>
        </div>
    );
}