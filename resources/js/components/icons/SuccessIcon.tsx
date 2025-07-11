import React from 'react';

interface SuccessIconProps {
  className?: string;
  width?: number;
  height?: number;
}

const SuccessIcon: React.FC<SuccessIconProps> = ({
  className = "",
  width = 90,
  height = 90
}) => {
  return (
    <svg
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 90 90"
      width={width}
      height={height}
      className={className}
    >
      <style>{`.st1{fill:#49ad5b}`}</style>
      <path
        className="st1"
        d="M45 0C20.1 0 0 20.2 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zm24.4 33.8l-27 27c-2.6 2.6-6.8 2.6-9.3 0L20.6 48.3c-1.5-1.4-1.6-3.8-.2-5.3 1.4-1.5 3.8-1.6 5.3-.2l.2.2 11.8 11.8L64 28.5c1.4-1.5 3.8-1.6 5.3-.2 1.5 1.4 1.6 3.8.2 5.3 0 .1 0 .1-.1.2z"
      />
    </svg>
  );
};

export default SuccessIcon;
