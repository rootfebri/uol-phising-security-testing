import React from 'react';

interface ErrorIconProps {
  className?: string;
  width?: number;
  height?: number;
}

const ErrorIcon: React.FC<ErrorIconProps> = ({
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
        d="M45 0c-24.9 0-45 20.1-45 45s20.1 45 45 45 45-20.1 45-45-20.1-45-45-45zm19 58.7c1.5 1.4 1.6 3.8.2 5.3-1.4 1.5-3.8 1.6-5.3.2l-.2-.2L45 50.3 31.3 64c-1.4 1.5-3.8 1.6-5.3.2-1.5-1.4-1.6-3.8-.2-5.3l.2-.2L39.7 45 26 31.3c-1.5-1.4-1.6-3.8-.2-5.3 1.4-1.5 3.8-1.6 5.3-.2l.2.2L45 39.7 58.7 26c1.4-1.5 3.8-1.6 5.3-.2 1.5 1.4 1.6 3.8.2 5.3l-.2.2L50.3 45 64 58.7z"
      />
    </svg>
  );
};

export default ErrorIcon;
