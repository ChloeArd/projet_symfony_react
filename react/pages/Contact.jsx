import {useEffect} from "react";

export const Contact = function () {

  useEffect(() => {document.title = "Contact";}, []);

  return <h1>Contact</h1>;
};
