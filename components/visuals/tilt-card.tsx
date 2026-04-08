"use client"

import { useRef, useState, type ReactNode } from "react"

interface TiltCardProps {
  children: ReactNode
  className?: string
  glareEnabled?: boolean
}

export function TiltCard({ children, className = "", glareEnabled = true }: TiltCardProps) {
  const cardRef = useRef<HTMLDivElement>(null)
  const [transform, setTransform] = useState("")
  const [glareStyle, setGlareStyle] = useState({ opacity: 0, transform: "" })

  const handleMouseMove = (e: React.MouseEvent<HTMLDivElement>) => {
    if (!cardRef.current) return

    const rect = cardRef.current.getBoundingClientRect()
    const x = e.clientX - rect.left
    const y = e.clientY - rect.top
    const centerX = rect.width / 2
    const centerY = rect.height / 2

    const rotateX = (y - centerY) / 10
    const rotateY = (centerX - x) / 10

    setTransform(`perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`)

    if (glareEnabled) {
      const glareX = (x / rect.width) * 100
      const glareY = (y / rect.height) * 100
      setGlareStyle({
        opacity: 0.15,
        transform: `translate(${glareX - 50}%, ${glareY - 50}%)`,
      })
    }
  }

  const handleMouseLeave = () => {
    setTransform("")
    setGlareStyle({ opacity: 0, transform: "" })
  }

  return (
    <div
      ref={cardRef}
      className={`relative overflow-hidden transition-transform duration-200 ease-out ${className}`}
      style={{ transform }}
      onMouseMove={handleMouseMove}
      onMouseLeave={handleMouseLeave}
    >
      {children}
      {glareEnabled && (
        <div
          className="absolute inset-0 pointer-events-none"
          style={{
            background: "radial-gradient(circle at center, rgba(255,255,255,0.8) 0%, transparent 50%)",
            opacity: glareStyle.opacity,
            transform: glareStyle.transform,
            transition: "opacity 0.2s ease",
          }}
        />
      )}
    </div>
  )
}
