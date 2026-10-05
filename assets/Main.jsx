import { useEffect, useState } from 'react'

export default function Main() {
  const [msg, setMsg] = useState('Cargando...')

  useEffect(() => {
    fetch('/api/ping')
      .then(r => r.json())
      .then(d => setMsg(d.mensaje))
      .catch(() => setMsg('No se pudo conectar con Symfony'))
  }, [])

  return (
    <div className="min-h-screen grid place-items-center bg-slate-100">
      <div className="text-center">
        <h1 className="text-4xl font-bold text-blue-700">SIALEG</h1>
        <p className="mt-2 text-slate-600">{msg}</p>
      </div>
    </div>
  )
}
