import { PropsWithChildren } from 'react';

export default function Guest({ children }: PropsWithChildren) {
    return (
        <div className="flex h-screen w-full items-center justify-center px-4">
            {children}
        </div>
    );
}
