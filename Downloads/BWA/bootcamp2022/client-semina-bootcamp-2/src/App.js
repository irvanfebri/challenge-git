
import { useState } from 'react';
import {
  BrowserRouter,
  Route,
  Routes,
} from "react-router-dom";
import './App.css';


function App() {
  
    
  return (
    <>

<BrowserRouter>
<ul>
        <li>
          <a href="/">Home</a>
        </li>
        <li>
          <a href="/categories">Categories</a>
        </li>
        <li>
          <a href="/about">About</a>
        </li>
      </ul> 

      <Routes>
        
      </Routes>
  </BrowserRouter>
 
         
        
    </>

  );
}

export default App;
