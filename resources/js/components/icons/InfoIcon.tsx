import React from 'react';

interface InfoIconProps {
  className?: string;
  width?: number;
  height?: number;
}

const InfoIcon: React.FC<InfoIconProps> = ({ 
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
      <style>{`.st0{fill:#2fa5c2}`}</style>
      <path 
        className="st0" 
        d="M45 0c-24.9 0-45 20.1-45 45s20.1 45 45 45 45-20.1 45-45-20.1-45-45-45zm3.3 13.7c2.9 0 5.2 2.4 5.2 5.3s-2.4 5.2-5.3 5.2-5.2-2.3-5.2-5.2c0-2.9 2.3-5.2 5.3-5.3-.1 0 0 0 0 0zm3.3 54.3l-4.6 2.6-.2.1c-.4.2-.9.4-1.3.5-1 .3-2 .3-3 0-1.5-.4-2.8-1.4-3.6-2.7-.6-1-.9-2.1-.9-3.2 0-.4 0-.7.1-1.1l5.2-27.2h-2.4c-2.1 0-3.8-1.7-3.8-3.8s1.7-3.8 3.8-3.8H44c3.8 0 6.9 3.1 6.9 6.9 0 .4 0 .8-.1 1.3l-4.8 25 1.9-1.1c1.8-1 4.1-.4 5.1 1.4s.4 4.1-1.4 5.1z"
      />
    </svg>
  );
};

export default InfoIcon;
