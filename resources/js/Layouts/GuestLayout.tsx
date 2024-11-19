import { ThemeProvider } from '@/components/theme-provider';
import { PropsWithChildren } from 'react';

export default function Guest({ children }: PropsWithChildren) {
    return (
        <ThemeProvider defaultTheme="system" storageKey="vite-ui-theme">
            <div className="flex h-screen w-full items-center justify-center px-4">
                {children}
            </div>
        </ThemeProvider>
    );
}
