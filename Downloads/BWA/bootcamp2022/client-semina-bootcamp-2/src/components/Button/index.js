import React from 'react'

export default function Buton({onClick, children}) {
  return <button onClick={onClick}>{children}</button>;
}
