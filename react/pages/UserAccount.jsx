import {useEffect} from "react";

export const UserAccount = function () {

  useEffect(() => {document.title = "Mon compte";}, []);

  return <h1>Mon compte</h1>;
};
