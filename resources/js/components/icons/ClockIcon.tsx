import React from 'react';

interface ClockIconProps {
  className?: string;
  width?: number;
  height?: number;
}

const ClockIcon: React.FC<ClockIconProps> = ({
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
      <style>{`.st5{fill:#414042}`}</style>
      <path
        className="st5"
        d="M45 0c-24.9 0-45 20.1-45 45s20.1 45 45 45 45-20.1 45-45c0-24.8-20.1-45-45-45zm18.2 58.2c-1.1 1.8-3.4 2.4-5.1 1.3l-15-8.9c-1.1-.7-1.8-1.9-1.8-3.2v-24.9c0-2.1 1.7-3.8 3.8-3.8s3.8 1.7 3.8 3.8v22.8l13.2 7.8c1.6 1 2.2 3.3 1.1 5.1z"
      />
    </svg>
  );
};

export default ClockIcon;
