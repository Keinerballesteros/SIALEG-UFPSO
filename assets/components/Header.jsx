import logoSialeg from '../images/logoSIALEG.png'
import logoHorizontalUFPSO from '../images/logoHorizontalUFPSO.png'

export default function Header() {
  return (
    <header
      style={{ backgroundColor: '#e2001a' }}
      className="h-[72px] flex items-stretch justify-between shadow-md"
    >
      <div className="flex items-center pl-4">
        <img
          src={logoSialeg}
          alt="SIALEG"
          className="h-12 bg-white object-contain"
        />
      </div>

      {/* Mismo ancho (w-64) que el menú lateral para que queden alineados */}
      <div className="bg-white flex items-center justify-center md:w-64">
        <img
          src={logoHorizontalUFPSO}
          alt="Universidad Francisco de Paula Santander Ocaña"
          className="h-full max-w-full object-contain"
        />
      </div>
    </header>
  )
}
