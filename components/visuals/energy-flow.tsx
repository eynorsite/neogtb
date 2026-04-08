"use client"

import { useEffect, useState } from "react"

export function EnergyFlow({ className = "" }: { className?: string }) {
  const [flowProgress, setFlowProgress] = useState(0)

  useEffect(() => {
    const interval = setInterval(() => {
      setFlowProgress((prev) => (prev + 1) % 100)
    }, 50)

    return () => clearInterval(interval)
  }, [])

  return (
    <div className={`relative ${className}`}>
      <svg viewBox="0 0 600 300" className="w-full h-full">
        <defs>
          <linearGradient id="energyGradient" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="0%" stopColor="#10b981" stopOpacity="0" />
            <stop offset="50%" stopColor="#10b981" stopOpacity="1" />
            <stop offset="100%" stopColor="#10b981" stopOpacity="0" />
          </linearGradient>
          <filter id="energyGlow">
            <feGaussianBlur stdDeviation="4" result="blur" />
            <feMerge>
              <feMergeNode in="blur" />
              <feMergeNode in="SourceGraphic" />
            </feMerge>
          </filter>
        </defs>

        {/* Building icons */}
        <g className="text-dark-300">
          {/* Source building */}
          <rect x="20" y="80" width="100" height="140" rx="8" fill="currentColor" />
          <rect x="35" y="100" width="25" height="30" rx="2" fill="white" opacity="0.3" />
          <rect x="70" y="100" width="25" height="30" rx="2" fill="white" opacity="0.3" />
          <rect x="35" y="145" width="25" height="30" rx="2" fill="white" opacity="0.3" />
          <rect x="70" y="145" width="25" height="30" rx="2" fill="white" opacity="0.3" />
          <rect x="35" y="190" width="25" height="30" rx="2" fill="white" opacity="0.3" />
          <rect x="70" y="190" width="25" height="30" rx="2" fill="white" opacity="0.3" />

          {/* GTB Control Center */}
          <rect x="250" y="100" width="100" height="100" rx="12" fill="#102A43" />
          <text x="300" y="145" textAnchor="middle" fill="white" fontSize="12" fontWeight="600">
            GTB
          </text>
          <text x="300" y="165" textAnchor="middle" fill="#10b981" fontSize="10">
            Control
          </text>

          {/* Target building */}
          <rect x="480" y="80" width="100" height="140" rx="8" fill="currentColor" />
          <rect x="495" y="100" width="25" height="30" rx="2" fill="#10b981" opacity="0.6" />
          <rect x="530" y="100" width="25" height="30" rx="2" fill="#10b981" opacity="0.6" />
          <rect x="495" y="145" width="25" height="30" rx="2" fill="#10b981" opacity="0.6" />
          <rect x="530" y="145" width="25" height="30" rx="2" fill="#10b981" opacity="0.6" />
          <rect x="495" y="190" width="25" height="30" rx="2" fill="#10b981" opacity="0.6" />
          <rect x="530" y="190" width="25" height="30" rx="2" fill="#10b981" opacity="0.6" />
        </g>

        {/* Energy flow paths */}
        <path
          d="M120 150 Q185 150 185 150 L250 150"
          fill="none"
          stroke="#e4e4e7"
          strokeWidth="3"
          strokeDasharray="8,4"
        />
        <path
          d="M350 150 Q415 150 415 150 L480 150"
          fill="none"
          stroke="#e4e4e7"
          strokeWidth="3"
          strokeDasharray="8,4"
        />

        {/* Animated energy particles - Left to Center */}
        {[0, 1, 2].map((i) => {
          const progress = ((flowProgress + i * 33) % 100) / 100
          const x = 120 + progress * 130
          return (
            <circle
              key={`left-${i}`}
              cx={x}
              cy={150}
              r={4}
              fill="#10b981"
              filter="url(#energyGlow)"
              opacity={0.3 + progress * 0.7}
            />
          )
        })}

        {/* Animated energy particles - Center to Right */}
        {[0, 1, 2].map((i) => {
          const progress = ((flowProgress + i * 33) % 100) / 100
          const x = 350 + progress * 130
          return (
            <circle
              key={`right-${i}`}
              cx={x}
              cy={150}
              r={4}
              fill="#10b981"
              filter="url(#energyGlow)"
              opacity={0.3 + progress * 0.7}
            />
          )
        })}

        {/* Data flow indicators */}
        <g className="text-accent-500">
          <circle cx="300" cy="90" r="6" fill="currentColor" className="animate-pulse" />
          <circle cx="300" cy="210" r="6" fill="currentColor" className="animate-pulse" style={{ animationDelay: "0.5s" }} />
        </g>

        {/* Labels */}
        <text x="70" y="250" textAnchor="middle" fill="#71717a" fontSize="12" fontWeight="500">
          Consommation
        </text>
        <text x="70" y="268" textAnchor="middle" fill="#ef4444" fontSize="14" fontWeight="700">
          245 kWh
        </text>

        <text x="530" y="250" textAnchor="middle" fill="#71717a" fontSize="12" fontWeight="500">
          Optimisé
        </text>
        <text x="530" y="268" textAnchor="middle" fill="#10b981" fontSize="14" fontWeight="700">
          159 kWh
        </text>

        <text x="300" y="250" textAnchor="middle" fill="#71717a" fontSize="11" fontWeight="500">
          Économies réalisées
        </text>
        <text x="300" y="270" textAnchor="middle" fill="#eab308" fontSize="16" fontWeight="700">
          -35%
        </text>
      </svg>
    </div>
  )
}
