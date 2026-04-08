"use client"

export function MorphingShapes({ className = "" }: { className?: string }) {
  return (
    <div className={`absolute inset-0 overflow-hidden pointer-events-none ${className}`}>
      {/* Large gradient blob - top right */}
      <div
        className="absolute -top-40 -right-40 w-[600px] h-[600px] rounded-full opacity-30"
        style={{
          background: "radial-gradient(circle, rgba(16, 185, 129, 0.4) 0%, transparent 70%)",
          animation: "morphBlob1 20s ease-in-out infinite",
        }}
      />

      {/* Medium gradient blob - bottom left */}
      <div
        className="absolute -bottom-20 -left-20 w-[400px] h-[400px] rounded-full opacity-20"
        style={{
          background: "radial-gradient(circle, rgba(234, 179, 8, 0.5) 0%, transparent 70%)",
          animation: "morphBlob2 15s ease-in-out infinite",
        }}
      />

      {/* Small accent blob - center */}
      <div
        className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] rounded-full opacity-10"
        style={{
          background: "radial-gradient(circle, rgba(16, 42, 67, 0.6) 0%, transparent 70%)",
          animation: "morphBlob3 25s ease-in-out infinite",
        }}
      />

      {/* Floating geometric shapes */}
      <svg className="absolute inset-0 w-full h-full" style={{ opacity: 0.1 }}>
        <defs>
          <linearGradient id="shapeGrad1" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stopColor="#10b981" />
            <stop offset="100%" stopColor="#059669" />
          </linearGradient>
        </defs>

        {/* Animated circles */}
        <circle cx="10%" cy="20%" r="60" fill="url(#shapeGrad1)" opacity="0.5">
          <animate
            attributeName="cy"
            values="20%;25%;20%"
            dur="8s"
            repeatCount="indefinite"
          />
        </circle>

        <circle cx="85%" cy="70%" r="40" fill="url(#shapeGrad1)" opacity="0.3">
          <animate
            attributeName="cx"
            values="85%;88%;85%"
            dur="10s"
            repeatCount="indefinite"
          />
        </circle>

        {/* Animated rectangles */}
        <rect x="70%" y="15%" width="80" height="80" rx="16" fill="url(#shapeGrad1)" opacity="0.2">
          <animateTransform
            attributeName="transform"
            type="rotate"
            from="0 75 15"
            to="360 75 15"
            dur="30s"
            repeatCount="indefinite"
          />
        </rect>

        <rect x="15%" y="75%" width="60" height="60" rx="12" fill="#eab308" opacity="0.15">
          <animateTransform
            attributeName="transform"
            type="rotate"
            from="0 15 75"
            to="-360 15 75"
            dur="25s"
            repeatCount="indefinite"
          />
        </rect>
      </svg>

      <style jsx>{`
        @keyframes morphBlob1 {
          0%, 100% {
            transform: translate(0, 0) scale(1);
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
          }
          25% {
            transform: translate(20px, -30px) scale(1.05);
            border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%;
          }
          50% {
            transform: translate(-20px, 20px) scale(0.95);
            border-radius: 40% 60% 60% 40% / 60% 30% 70% 40%;
          }
          75% {
            transform: translate(10px, -10px) scale(1.02);
            border-radius: 60% 40% 30% 70% / 40% 50% 60% 50%;
          }
        }

        @keyframes morphBlob2 {
          0%, 100% {
            transform: translate(0, 0) scale(1);
            border-radius: 40% 60% 60% 40% / 70% 30% 70% 30%;
          }
          33% {
            transform: translate(-30px, 20px) scale(1.1);
            border-radius: 60% 40% 30% 70% / 40% 60% 40% 60%;
          }
          66% {
            transform: translate(20px, -20px) scale(0.9);
            border-radius: 30% 70% 70% 30% / 60% 40% 60% 40%;
          }
        }

        @keyframes morphBlob3 {
          0%, 100% {
            transform: translate(-50%, -50%) scale(1) rotate(0deg);
          }
          50% {
            transform: translate(-50%, -50%) scale(1.2) rotate(180deg);
          }
        }
      `}</style>
    </div>
  )
}
