import {createContext, useState} from "react";

export const CartContextProvider = createContext({});

export const CartContext = function ({children}) {
    const [cartUpdated, setCartUpdated] = useState(false);

    return(
      <CartContextProvider.Provider value={{cartUpdated, setCartUpdated}}>
          {children}
      </CartContextProvider.Provider>
    );
}