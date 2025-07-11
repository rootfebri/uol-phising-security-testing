import React from 'react';

interface StopIconProps {
  className?: string;
  width?: number;
  height?: number;
}

const StopIcon: React.FC<StopIconProps> = ({
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
      <style>{`.st2{fill:#cb2a2a}`}</style>
      <path
        className="st2"
        d="M88.9 40.9l-18.3-31.8c-1.5-2.6-4.2-4.2-7.2-4.2H26.6c-3 0-5.7 1.6-7.2 4.2L1.1 40.9c-1.5 2.6-1.5 5.7 0 8.3L19.5 81c1.5 2.6 4.2 4.2 7.2 4.2h36.7c3 0 5.7-1.6 7.2-4.2l18.3-31.8c1.5-2.3 1.4-5.6 0-8.3zm-27 7.9H28.1c-2.1 0-3.8-1.7-3.8-3.8s1.7-3.8 3.8-3.8h33.8c2.1 0 3.7 1.7 3.7 3.8s-1.7 3.8-3.7 3.8z"
      />
    </svg>
  );
};

export default StopIcon;
