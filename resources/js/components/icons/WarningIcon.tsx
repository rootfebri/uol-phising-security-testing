import React from 'react';

interface WarningIconProps {
  className?: string;
  width?: number;
  height?: number;
}

const WarningIcon: React.FC<WarningIconProps> = ({
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
      <style>{`.st4{fill:#ffbc2c}`}</style>
      <path
        className="st4"
        d="M89.1 74.1l-38.8-64.6c-1.8-3-5.6-3.9-8.6-2.2-.9.5-1.6 1.3-2.2 2.2L.9 74.1c-1.8 3-.8 6.8 2.2 8.6 1 .6 2.1.9 3.2.9h77.5c3.5 0 6.2-2.8 6.2-6.3 0-1.1-.3-2.2-.9-3.2zm-47.8-42.9c0-2.1 1.7-3.8 3.8-3.8s3.8 1.7 3.8 3.8v25.1c0 2.1-1.7 3.8-3.8 3.8s-3.8-1.7-3.8-3.8v-25.1zm3.7 43.6c-2.6 0-4.7-2.1-4.7-4.7s2.1-4.7 4.7-4.7 4.7 2.1 4.7 4.7-2.1 4.7-4.7 4.7z"
      />
    </svg>
  );
};

export default WarningIcon;
